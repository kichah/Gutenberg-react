import { useBlockProps, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
  const blockProps = useBlockProps({
    className: 'p-8 bg-gray-100 border-dashed border-gray-400', // Use Tailwind in editor
  });

  return (
    <div {...blockProps}>
      <div>
        <RichText
          tagName='h2'
          className='text-4xl font-bold text-gray-800' // More Tailwind!
          value={attributes.title}
          onChange={(title) => setAttributes({ title })}
          placeholder={__('Hero Title', 'soltani')}
        />
        <RichText
          tagName='p'
          className='mt-2 text-lg text-gray-600'
          value={attributes.subtitle}
          onChange={(subtitle) => setAttributes({ subtitle })}
          placeholder={__('Hero subtitle(…)', 'soltani')}
        />
      </div>
    </div>
  );
}
