import {NgModule} from '@angular/core';
import {TranslationPipe} from "./pipe/translation.pipe";
import {PaginationComponent} from "./component/pagination.component";
import {CommonModule} from "@angular/common";

@NgModule({
    imports: [
        CommonModule,
    ],
    declarations: [
        PaginationComponent,
        TranslationPipe,
    ],
    exports: [
        PaginationComponent,
        TranslationPipe,
    ],
    providers: []
})
export class SharedModule {}
