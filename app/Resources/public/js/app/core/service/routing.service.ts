import {Inject, Injectable} from '@angular/core';
import {BaseUrlInjectToken} from '../provider/base-url.provider';
import {FosJsRouter} from '../provider/fos-js-router.provider';
import {RequestLocaleInjectToken} from '../provider/request-locale.provider';

@Injectable()
export class RoutingService {
    constructor(private fosJsRouter: FosJsRouter,
                @Inject(BaseUrlInjectToken) private baseUrl: string,
                @Inject(RequestLocaleInjectToken) private requestLocale: string) {
    }

    public generate(route: string, params = {}): string {
        return this.fosJsRouter.generate(route, {_locale: this.requestLocale, ...params});
    }

    public trimBaseUrl(route: string): string {
        return route.slice(this.baseUrl.length);
    }
}
