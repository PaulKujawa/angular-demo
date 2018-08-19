import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {MatPaginatorModule} from '@angular/material/paginator';
import {PaginationComponent} from 'app/shared/component/pagination.component';
import {LazyImgDirective} from 'app/shared/directive/lazy-img.directive';
import {RoutePipe} from 'app/shared/pipe/route.pipe';
import {TranslationPipe} from 'app/shared/pipe/translation.pipe';

const directives = [
    LazyImgDirective,
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
})
export class SharedModule {
}
