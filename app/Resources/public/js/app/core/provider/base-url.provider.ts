import {InjectionToken} from '@angular/core';

export function baseUrlFactory(): string {
    return window.appInject.baseUrl;
}

export const BaseUrlInjectToken = new InjectionToken('baseUrl');

export const baseUrlProvider = {provide: BaseUrlInjectToken, useFactory: baseUrlFactory};
