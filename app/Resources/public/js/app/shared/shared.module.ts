import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {MatPaginatorModule} from '@angular/material/paginator';
import {PaginationComponent} from './component/pagination.component';
import {InViewportDirective} from './directive/in-viewport.directe';
import {RoutePipe} from './pipe/route.pipe';
import {TranslationPipe} from './pipe/translation.pipe';

const directives = [
    InViewportDirective,
    PaginationComponent,
    RoutePipe,
    TranslationPipe,
];

@NgModule({
    imports: [
        CommonModule,
        MatPaginatorModule,
    ],
    declarations: directives,
    exports: directives,
    providers: [],
})
export class SharedModule {
}
