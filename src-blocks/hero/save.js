import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
  const { title, subtitle, imageUrl, titleColor, subtitleColor } = attributes;
  const blockProps = useBlockProps.save();

  // Create a style object for the background
  const bgStyle = {
    backgroundImage: imageUrl ? `url(${imageUrl})` : 'none',
  };

  return (
    <div {...blockProps}>
      <section className='hero'>
        <div className='hero-media' style={bgStyle}></div>
        <div className='hero-overlay container'>
          <RichText.Content
            tagName='h1'
            value={title}
            style={{ color: titleColor }}
          />
          <RichText.Content
            tagName='p'
            value={subtitle}
            style={{ color: subtitleColor }}
          />
        </div>
      </section>
    </div>
  );
}
