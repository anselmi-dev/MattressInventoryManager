import './bootstrap';

import * as FilePond from 'filepond';
// Import Lang
// import es_ES from 'filepond/locale/es-es.js';
// Import the plugin code
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
// Import the plugin code
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
// Import the plugin code
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
// Import the plugin styles
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import 'filepond/dist/filepond.css';

// Register the plugin
FilePond.registerPlugin(FilePondPluginFileValidateSize);
// Register the plugin
FilePond.registerPlugin(FilePondPluginFileValidateType);
// Register the plugin
FilePond.registerPlugin(FilePondPluginImagePreview);
// Register options
// FilePond.setOptions(es_ES);