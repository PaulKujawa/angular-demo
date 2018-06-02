import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {MatPaginatorModule} from '@angular/material/paginator';
import {PaginationComponent} from 'app/shared/component/pagination.component';
import {InViewportDirective} from 'app/shared/directive/in-viewport.directe';
import {RoutePipe} from 'app/shared/pipe/route.pipe';
import {TranslationPipe} from 'app/shared/pipe/translation.pipe';

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
