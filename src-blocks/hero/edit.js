import {
  useBlockProps,
  RichText,
  InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';
import { MediaUpload } from '@wordpress/media-utils';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
  const { title, subtitle, imageUrl, imageId } = attributes;

  // Function to handle image selection
  const onSelectImage = (media) => {
    setAttributes({
      imageUrl: media.url,
      imageId: media.id,
    });
  };

  // Function to remove image
  const onRemoveImage = () => {
    setAttributes({
      imageUrl: '',
      imageId: null,
    });
  };

  // Add the dynamic background image style to blockProps
  const blockProps = useBlockProps({
    className: 'p-8 bg-gray-100 border-dashed border-gray-400',
    style: {
      backgroundImage: imageUrl ? `url(${imageUrl})` : 'none',
      backgroundSize: 'cover',
      backgroundPosition: 'center',
    },
  });

  return (
    <>
      {/* This adds the "Settings" sidebar */}
      <InspectorControls>
        <PanelBody title={__('Background Settings', 'soltani')}>
          <div className='editor-media-upload'>
            <MediaUpload
              onSelect={onSelectImage}
              allowedTypes={['image']}
              value={imageId}
              render={({ open }) => (
                <Button onClick={open} isPrimary>
                  {!imageId
                    ? __('Select Image', 'soltani')
                    : __('Change Image', 'soltani')}
                </Button>
              )}
            />
            {imageId && (
              <Button
                onClick={onRemoveImage}
                isDestructive
                isLink
                style={{ marginLeft: '10px' }}
              >
                {__('Remove Image', 'soltani')}
              </Button>
            )}
          </div>
        </PanelBody>
      </InspectorControls>

      {/* This is your block preview */}
      <div {...blockProps}>
        <div>
          <h1
            className='text-center bg-amber-500 text-cyan-600'
            style={{ color: 'white', background: 'rgba(0,0,0,0.5)' }}
          >
            Hero Section (Editor)
          </h1>
          <RichText
            tagName='h1'
            className='text-4xl font-bold text-gray-800' // You might want to make these text colors white
            value={title}
            onChange={(title) => setAttributes({ title })}
            placeholder={__('Hero Title', 'soltani')}
          />
          <RichText
            tagName='p'
            className='mt-2 text-lg text-gray-600'
            value={subtitle}
            onChange={(subtitle) => setAttributes({ subtitle })}
            placeholder={__('Hero subtitle(…)', 'soltani')}
          />
        </div>
      </div>
    </>
  );
}
