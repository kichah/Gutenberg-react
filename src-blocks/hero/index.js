import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import Edit from './edit.js';
import save from './save.js';
import './style.scss';
import './editor.css'; // Add this line

registerBlockType(metadata.name, {
  /**
   * @see ./edit.js
   */
  edit: Edit,
  /**
   * @see ./save.js
   */
  save,
});
