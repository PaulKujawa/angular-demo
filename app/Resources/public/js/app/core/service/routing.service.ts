import {Injectable} from '@angular/core';

@Injectable()
export class RoutingService {
    private routing: FosJsRouting;
    private requestLocale: string;
    private baseUrl: string;

    constructor() {
        this.routing = window.Routing;
        this.requestLocale = window.appInject.requestLocale;
        this.baseUrl = window.appInject.baseUrl;
    }

    generate(route: string, params = {}): string {
        (params as any)['_locale'] = this.requestLocale;

        return this.routing.generate(route, params);
    }

    trimBaseUrl(route: string): string {
        return route.slice(this.baseUrl.length);
    }
}
