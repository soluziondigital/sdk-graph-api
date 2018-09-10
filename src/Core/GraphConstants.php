<?php 
namespace Microsoft\Graph\Core;

final class GraphConstants
{
    // Esto se sobreescribre en el objeto Graph
    const API_VERSION = "v1.0";
    const REST_ENDPOINT = "https://graph.microsoft.com/";

    const SDK_VERSION = "1.3.2";

    const MAX_PAGE_SIZE = 999;
    const MAX_PAGE_SIZE_ERROR = "Page size must be less than " . self::MAX_PAGE_SIZE;
    const TIMEOUT = "Timeout error";

    const BASE_URL_MISSING = "Base URL cannot be null or empty.";
    const REQUEST_TIMED_OUT = "The request timed out.";
    const UNABLE_TO_CREATE_INSTANCE_OF_TYPE = "Unable to create instance of type";

    const INVALID_FILE = "Unable to open file stream for the given path.";
    const NO_ACCESS_TOKEN = "No access token has been provided.";
    const NO_APP_ID = "No app ID has been provided.";
    const NO_APP_SECRET = "No app secret has been provided.";

    const UNABLE_TO_PARSE_RESPONSE = "The HTTP client sent back an invalid response";
}
