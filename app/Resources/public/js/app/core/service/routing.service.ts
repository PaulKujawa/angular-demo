import {Inject, Injectable} from '@angular/core';
import {CoreModule} from 'app/core/core.module';
import {BaseUrlInjectToken, FosRouterInjectToken, RequestLocaleInjectToken} from 'app/core/core.token';

@Injectable({
    providedIn: CoreModule,
})
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
