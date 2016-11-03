import {Injectable} from "@angular/core";

@Injectable()
export class RoutingService {
    private routing: FosJsRouting;
    private requestLocale: string;

    constructor() {
        this.routing = window.Routing;
        this.requestLocale = window.baInject.requestLocale;
        this.routing.setBaseUrl(window.baInject.baseUrl);
    }

    generate(route: string, params = {}): string {
        params['_locale'] = this.requestLocale;

        return this.routing.generate(route, params);
    }
}
