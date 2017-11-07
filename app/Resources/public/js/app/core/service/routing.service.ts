import {Inject, Injectable} from '@angular/core';

@Injectable()
export class RoutingService {
    constructor(@Inject('window.Routing') private routing: FosJsRouting,
                @Inject('window.appInject.baseUrl') private baseUrl: string,
                @Inject('window.appInject.requestLocale') private requestLocale: string) {
    }

    public generate(route: string, params = {}): string {
        return this.routing.generate(route, {_locale: this.requestLocale, ...params});
    }

    public trimBaseUrl(route: string): string {
        return route.slice(this.baseUrl.length);
    }
}
