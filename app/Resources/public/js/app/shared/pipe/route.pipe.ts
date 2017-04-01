import {Pipe} from '@angular/core';
import {PipeTransform} from '@angular/core';
import {RoutingService} from '../../core/service/routing.service';

/*
 * Generates a route
 *
 * Usage
 *  value|route:params
 * Example
 *  {{ 'app_root_i18n'|route }}
 *  {{ 'app_recipes'|route:{page:'1'}:false }}
 */

@Pipe({
    name: 'route'
})
export class RoutePipe implements PipeTransform {
    constructor(private routingService: RoutingService) {}

    transform(value: string, parameters?: {}): string {
        return this.routingService.generate(value, parameters);
    }
}
