import {InjectionToken} from '@angular/core';

export function windowFactory(): Window {
    return window;
}

export const WindowInjectToken = new InjectionToken('window');

export const windowProvider = {provide: WindowInjectToken, useFactory: windowFactory};
