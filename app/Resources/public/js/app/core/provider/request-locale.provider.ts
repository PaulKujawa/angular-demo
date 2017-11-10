import {InjectionToken} from '@angular/core';

export function requestLocaleFactory(): string {
    return window.appInject.requestLocale;
}

export const RequestLocaleInjectToken = new InjectionToken('requestLocale');

export const requestLocaleProvider = {provide: RequestLocaleInjectToken, useFactory: requestLocaleFactory};
