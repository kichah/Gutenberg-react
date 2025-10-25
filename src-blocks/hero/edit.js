import {
  useBlockProps,
  RichText,
  InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';
import { MediaUpload } from '@wordpress/media-utils';
import { __ } from '@wordpress/i18n';
import { ColorPicker } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
  const { title, subtitle, imageUrl, imageId, titleColor, subtitleColor } =
    attributes;

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
    className: 'p-8 bg-gray-100 border-dashed border-gray-400 ',
    style: {
      backgroundImage: imageUrl ? `url(${imageUrl})` : 'none',
      backgroundSize: 'cover',
      backgroundPosition: 'center',
    },
  });

  return (
    <>
      {/* Settings sidebar */}
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

        <PanelBody title={__('Text Colors', 'soltani')} initialOpen={false}>
          <div style={{ marginBottom: '20px' }}>
            <p style={{ fontWeight: '600', marginBottom: '8px' }}>
              {__('Title Color', 'soltani')}
            </p>
            <ColorPicker
              color={titleColor}
              onChangeComplete={(color) =>
                setAttributes({ titleColor: color.hex })
              }
              disableAlpha
            />
          </div>

          <div style={{ marginBottom: '20px' }}>
            <p style={{ fontWeight: '600', marginBottom: '8px' }}>
              {__('Subtitle Color', 'soltani')}
            </p>
            <ColorPicker
              color={subtitleColor}
              onChangeComplete={(color) =>
                setAttributes({ subtitleColor: color.hex })
              }
              disableAlpha
            />
          </div>

          {/* Reset buttons */}
          <div style={{ display: 'flex', gap: '8px', marginTop: '16px' }}>
            <Button
              isSmall
              onClick={() => setAttributes({ titleColor: '#ffffff' })}
            >
              {__('Reset Title', 'soltani')}
            </Button>
            <Button
              isSmall
              onClick={() => setAttributes({ subtitleColor: '#ffffff' })}
            >
              {__('Reset Subtitle', 'soltani')}
            </Button>
          </div>
        </PanelBody>
      </InspectorControls>

      {/* Block preview */}
      <div {...blockProps}>
        <div className='flex items-center justify-center flex-col text-center p-8'>
          <h1 className='text-center bg-gray-300 text-cyan-600 w-full'>
            Hero Section (Editor)
          </h1>
          <RichText
            tagName='h1'
            className='text-4xl font-bold'
            style={{ color: titleColor }}
            value={title}
            onChange={(title) => setAttributes({ title })}
            placeholder={__('Hero Title', 'soltani')}
          />
          <RichText
            tagName='p'
            className='mt-2 text-lg'
            style={{ color: subtitleColor }}
            value={subtitle}
            onChange={(subtitle) => setAttributes({ subtitle })}
            placeholder={__('Hero subtitle…', 'soltani')}
          />
        </div>
      </div>
    </>
  );
}
