import {Inject, Injectable} from '@angular/core';
import {BaseUrlInjectToken, FosRouterInjectToken, RequestLocaleInjectToken} from 'app/core/core.token';

@Injectable()
export class RoutingService {
    constructor(@Inject(FosRouterInjectToken) private fosJsRouter: FosJsRouter,
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
