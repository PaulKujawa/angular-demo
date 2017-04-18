import {Pipe} from '@angular/core';
import {PipeTransform} from '@angular/core';
import {RoutingService} from '../../core/service/routing.service';

/*
 * Every route path contains a locale prefix, that is required to generate these URIs.
 * Angular's router though, can not handle such dynamic route prefixes yet.
 * Therefore, the prefix is set in base.html.twig (base tag) and not part of paths registered in routing modules.
 *
 * When an API call is made, the whole generated URI can be used.
 * When a navigation link is needed, this pipe removes the prefix to match in routing modules registered paths.
 *
 * Usage
 *  value|route|trimBaseUrl
 * Example
 *  {{ 'app_root_i18n'|route|trimBaseUrl }}
 */

@Pipe({
    name: 'trimBaseUrl',
})
export class TrimBaseUrlPipe implements PipeTransform {
    constructor(private routingService: RoutingService) {}

    public transform(value: string): string {
        return this.routingService.trimBaseUrl(value);
    }
}
