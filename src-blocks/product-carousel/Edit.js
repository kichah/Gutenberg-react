import {
  useBlockProps,
  InspectorControls,
  RichText,
} from '@wordpress/block-editor';
import {
  PanelBody,
  SelectControl,
  RangeControl,
  ToggleControl,
  TextControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';
import { useState, useEffect } from '@wordpress/element';
import useEmblaCarousel from 'embla-carousel-react';

export default function Edit({ attributes, setAttributes }) {
  const {
    heading,
    productSource,
    category,
    productCount,
    autoplay,
    loop,
    orderBy,
  } = attributes;

  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);

  const [emblaRef, emblaApi] = useEmblaCarousel({
    loop,
    slidesToScroll: 1,
    align: 'start',
  });

  // Get responsive slides count
  const getSlidesToShow = () => {
    if (typeof window === 'undefined') return 4;
    const width = window.innerWidth;
    if (width < 480) return 1;
    if (width < 768) return 2;
    return 3;
  };

  const [slidesToShow, setSlidesToShow] = useState(getSlidesToShow());

  // Update slides on window resize
  useEffect(() => {
    const handleResize = () => {
      setSlidesToShow(getSlidesToShow());
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  // Manual autoplay in editor
  useEffect(() => {
    if (!emblaApi || !autoplay) return;

    const interval = setInterval(() => {
      emblaApi.scrollNext();
    }, 3000);

    return () => clearInterval(interval);
  }, [emblaApi, autoplay]);

  // Fetch WooCommerce categories
  const categories = useSelect((select) => {
    return select('core').getEntityRecords('taxonomy', 'product_cat', {
      per_page: -1,
    });
  }, []);

  // Fetch WooCommerce products
  useEffect(() => {
    setLoading(true);

    const endpoint = '/wc/store/v1/products';
    const queryParams = new URLSearchParams({
      per_page: productCount,
      orderby: orderBy,
    });

    if (category && category !== 0) {
      queryParams.append('category', category);
    }

    if (productSource === 'featured') {
      queryParams.append('featured', 'true');
    } else if (productSource === 'sale') {
      queryParams.append('on_sale', 'true');
    }

    apiFetch({
      path: `${endpoint}?${queryParams.toString()}`,
    })
      .then((data) => {
        setProducts(data);
        setLoading(false);
      })
      .catch((error) => {
        console.error('Error fetching products:', error);
        setLoading(false);
      });
  }, [productSource, category, productCount, orderBy]);

  const blockProps = useBlockProps({
    className: 'wc-product-carousel-block p-0 border-gray-200 border',
  });

  return (
    <>
      <InspectorControls>
        <PanelBody title={__('General Settings', 'soltani')} initialOpen={true}>
          <TextControl
            label={__('Heading', 'soltani')}
            value={heading}
            onChange={(value) => setAttributes({ heading: value })}
            placeholder={__('Enter section heading…', 'soltani')}
            help={__('The title displayed above the carousel', 'soltani')}
          />
        </PanelBody>

        <PanelBody title={__('Product Settings', 'soltani')}>
          <SelectControl
            label={__('Product Source', 'soltani')}
            value={productSource}
            options={[
              { label: __('Recent Products', 'soltani'), value: 'recent' },
              { label: __('Featured Products', 'soltani'), value: 'featured' },
              { label: __('On Sale', 'soltani'), value: 'sale' },
            ]}
            onChange={(value) => setAttributes({ productSource: value })}
          />

          <SelectControl
            label={__('Category', 'soltani')}
            value={category}
            options={[
              { label: __('All Categories', 'soltani'), value: 0 },
              ...(categories || []).map((cat) => ({
                label: cat.name,
                value: cat.id,
              })),
            ]}
            onChange={(value) => setAttributes({ category: parseInt(value) })}
          />

          <RangeControl
            label={__('Number of Products', 'soltani')}
            value={productCount}
            onChange={(value) => setAttributes({ productCount: value })}
            min={1}
            max={20}
          />

          <SelectControl
            label={__('Order By', 'soltani')}
            value={orderBy}
            options={[
              { label: __('Date', 'soltani'), value: 'date' },
              { label: __('Title', 'soltani'), value: 'title' },
              { label: __('Popularity', 'soltani'), value: 'popularity' },
              { label: __('Rating', 'soltani'), value: 'rating' },
              { label: __('Price: Low to High', 'soltani'), value: 'price' },
            ]}
            onChange={(value) => setAttributes({ orderBy: value })}
          />
        </PanelBody>

        <PanelBody title={__('Carousel Settings', 'soltani')}>
          <ToggleControl
            label={__('Autoplay', 'soltani')}
            checked={autoplay}
            onChange={(value) => setAttributes({ autoplay: value })}
            help={__('Automatically cycle through products', 'soltani')}
          />
          <ToggleControl
            label={__('Loop', 'soltani')}
            checked={loop}
            onChange={(value) => setAttributes({ loop: value })}
            help={__(
              'Continue carousel from beginning when reaching the end',
              'soltani'
            )}
          />
          <p style={{ fontSize: '12px', color: '#757575', marginTop: '16px' }}>
            {__(
              'Responsive: Mobile: 1, Tablet: 2–3, Desktop: 4 slides',
              'soltani'
            )}
          </p>
        </PanelBody>
      </InspectorControls>

      <section {...blockProps}>
        <div className='container '>
          <RichText
            tagName='h2'
            value={heading}
            onChange={(value) => setAttributes({ heading: value })}
            placeholder={__('Enter heading…', 'soltani')}
            allowedFormats={[]}
          />

          {loading ? (
            <div className='flex justify-center items-center p-8'>
              <div className='text-gray-500'>
                {__('Loading products…', 'soltani')}
              </div>
            </div>
          ) : (
            <>
              <div className='embla' ref={emblaRef}>
                <div className='embla__container'>
                  {products.length === 0 ? (
                    <div className='p-8 text-center text-gray-500'>
                      {__('No products found', 'soltani')}
                    </div>
                  ) : (
                    products.map((product) => (
                      <div
                        key={product.id}
                        className='embla__slide'
                        style={{ flex: `0 0 ${100 / slidesToShow}%` }}
                      >
                        <article className='card'>
                          {product.images?.[0] && (
                            <img
                              src={product.images[0].src}
                              alt={product.name}
                            />
                          )}
                          <h3>{product.name}</h3>
                          <p>
                            {product.short_description
                              ? product.short_description
                                  .replace(/<[^>]*>/g, '')
                                  .substring(0, 60) + '...'
                              : __('Premium quality product', 'soltani')}
                          </p>
                          <div className='product-price'>
                            {product.prices?.sale_price ? (
                              <>
                                <span
                                  style={{
                                    textDecoration: 'line-through',
                                    color: '#999',
                                    marginRight: '8px',
                                  }}
                                >
                                  {product.prices.currency_symbol}
                                  {product.prices.regular_price}
                                </span>
                                <span
                                  style={{
                                    color: '#d32f2f',
                                    fontWeight: 'bold',
                                  }}
                                >
                                  {product.prices.currency_symbol}
                                  {product.prices.sale_price}
                                </span>
                              </>
                            ) : (
                              <span>
                                {product.prices?.currency_symbol}
                                {product.prices?.price}
                              </span>
                            )}
                          </div>
                        </article>
                      </div>
                    ))
                  )}
                </div>
              </div>

              {products.length > slidesToShow && (
                <div className='carousel-navigation'>
                  <button
                    onClick={() => emblaApi?.scrollPrev()}
                    aria-label={__('Previous', 'soltani')}
                  >
                    <svg
                      width='24'
                      height='24'
                      viewBox='0 0 24 24'
                      fill='none'
                      stroke='currentColor'
                      strokeWidth='2'
                    >
                      <path d='M15 18l-6-6 6-6' />
                    </svg>
                  </button>
                  <button
                    onClick={() => emblaApi?.scrollNext()}
                    aria-label={__('Next', 'soltani')}
                  >
                    <svg
                      width='24'
                      height='24'
                      viewBox='0 0 24 24'
                      fill='none'
                      stroke='currentColor'
                      strokeWidth='2'
                    >
                      <path d='M9 18l6-6-6-6' />
                    </svg>
                  </button>
                </div>
              )}
            </>
          )}
        </div>
      </section>
    </>
  );
}
