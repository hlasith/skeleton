define([], function() {
    var Config = {

        'authEndpoint'                          : '',
        'tokenEndpoint'                         : '',
        'tournamentEndpoint'                    : '',
        'assetEndpoint'                         : '',

        'apiVersion'                            : 'application/json',      // used for accept header

        'appUrl'                                : '',
        'clientId'                              : '',

        'cookieNamePageReload'                  : '',
        'cookieNameIdTokenOrganizer'            : '',
        'cookieNameIdTokenOrganizerExpires'     : '',
        'cookieNameIdTokenUser'                 : '',
        'cookieNameIdTokenUserExpires'          : '',
        'cookieNameRefreshTokenUser'            : '',
        'cookieNameAccessTokenUser'             : '',
        'cookieNameCookieAgreement'             : '',
        'cookieNameGamezNotification'           : '',

        'defaultGameRankingRequestParameter'    : '',

        'clientScope'                           : 'openid',
        'debug'                                 : false
};
    return Config
});
