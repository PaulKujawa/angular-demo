import {RoutingService} from "../../../app/core/service/routing.service";

describe('RoutingService', () => {
    const routeNameStub = 'app_test';
    const routeStub = '/api/test';

    let service: RoutingService;

    beforeEach(() => {
        window.appInject = {
            requestLocale: 'de',
            baseUrl: ''
        };
        window.Routing = {
            generate: jasmine.createSpy('generate').and.callFake((route: string, params: {}) => {
                expect(route).toBe(routeNameStub);
                expect(params).toEqual({_locale: 'de'});

                return routeStub;
            }),
            setBaseUrl: (url: string) => {}
        };

        service = new RoutingService();
    });

    it('#generate should return path', () => {
        expect(service.generate(routeNameStub)).toBe(routeStub);
    });
});
