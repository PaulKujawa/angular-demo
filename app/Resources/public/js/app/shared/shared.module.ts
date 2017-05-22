import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {PaginationComponent} from './component/pagination.component';
import {RoutePipe} from './pipe/route.pipe';
import {TranslationPipe} from './pipe/translation.pipe';

const directives = [
    PaginationComponent,
    RoutePipe,
    TranslationPipe,
];

@NgModule({
    imports: [
        CommonModule,
    ],
    declarations: directives,
    exports: directives,
    providers: [],
})
export class SharedModule {
}
