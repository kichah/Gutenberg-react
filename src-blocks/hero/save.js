import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
  const blockProps = useBlockProps.save();

  return (
    <div {...blockProps}>
      <RichText.Content
        tagName='h2'
        className='text-4xl font-bold text-red-800'
        value={attributes.title}
      />
      <RichText.Content
        tagName='p'
        className='mt-2 text-lg text-blue-600'
        value={attributes.subtitle}
      />
    </div>
  );
}
