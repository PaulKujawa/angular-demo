import {InjectionToken} from '@angular/core';

export function authenticatedFactory(): boolean {
    return window.appInject.authenticated;
}

export const AuthenticatedInjectToken = new InjectionToken('authenticated');

export const authenticatedProvider = {provide: AuthenticatedInjectToken, useFactory: authenticatedFactory};
