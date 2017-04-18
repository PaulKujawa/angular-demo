import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {PaginationComponent} from './component/pagination.component';
import {RoutePipe} from './pipe/route.pipe';
import {TranslationPipe} from './pipe/translation.pipe';
import {TrimBaseUrlPipe} from './pipe/trimBaseUrl.pipe';

const directives = [
    PaginationComponent,
    RoutePipe,
    TranslationPipe,
    TrimBaseUrlPipe,
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
