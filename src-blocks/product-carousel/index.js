import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import Edit from './Edit.js';
import './style.scss';

registerBlockType(metadata.name, {
  edit: Edit,
});
