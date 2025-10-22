import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
  const blockProps = useBlockProps.save();

  return (
    <div {...blockProps}>
      <section className='hero'>
        <div
          className='hero-media'
          style="
          background-image: url('https://images.unsplash.com/photo-1633934542430-0905ccb5f050?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1025');
        "
        ></div>
        <div className='hero-overlay container'>
          <RichText.Content tagName='h1' value={attributes.title} />
          <RichText.Content tagName='p' value={attributes.subtitle} />
        </div>
      </section>
    </div>
  );
}
