import {Pipe} from '@angular/core';
import {PipeTransform} from '@angular/core';
import {RoutingService} from '../../core/service/routing.service';

/*
 * Generates a route, based on the base url
 *
 * Usage
 *  value|appRoute:params
 * Example
 *  {{ 'app_root_i18n'|appRoute }}
 *  {{ 'app_recipes'|appRoute:{page:'1'}:false }}
 */

@Pipe({
    name: 'appRoute',
})
export class RoutePipe implements PipeTransform {
    constructor(private routingService: RoutingService) {
    }

    public transform(value: string, parameters?: object): string {
        const url = this.routingService.generate(value, parameters);

        return this.routingService.trimBaseUrl(url);
    }
}
