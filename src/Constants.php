<?php
namespace GitChangeLog;

/**
 * Consants to be used across the application
 *
 * @author Chandra Shekhar Sharma <shekharsharma705@gmail.com>
 * @since 15-Mar-2018
 */
class Constants
{

    const COMMIT_ELEM_SEPARATOR = '|';

    const FORMAT_COMMIT_HASH = '%h';

    const FORMAT_AUTHOR_EMAIL = '%ae';

    const FORMAT_AUTHOR_NAME = '%aN';

    const FORMAT_COMMIT_TIMESTAMP = '%at';

    const FORMAT_COMMIT_MESSAGE = '%s';

    const COMMIT_TYPE_GENERAL = 'general';

    const COMMIT_TYPE_BUGFIX = 'fix';

    const COMMIT_TYPE_FEATURE = 'feature';

    const COMMIT_TYPE_SECURITY = 'security';

    const OUTPUT_FORMAT_HTML = 'html';

    const OUTPUT_FORMAT_MARKDOWN = 'markdown';

    const OUTPUT_FORMAT_REMARKUP = 'remarkup';

    const OUTPUT_FORMAT_JSON = 'json';
}
