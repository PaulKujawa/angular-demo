import * as isMobile from 'ismobilejs';

interface IsMobileJs {
    apple: {
        phone: boolean;
        ipod: boolean;
        tablet: boolean;
        device: boolean;
    };

    android: {
        phone: boolean;
        tablet: boolean;
        device: boolean;
    };

    amazon: {
        phone: boolean;
        tablet: boolean;
        device: boolean;
    };

    windows: {
        phone: boolean;
        tablet: boolean;
        device: boolean;
    };

    seven_inch: boolean;
    any: boolean;
    phone: boolean;
    tablet: boolean;
}

export class DeviceDetectService {
    public isMobile: IsMobileJs = isMobile;
}
