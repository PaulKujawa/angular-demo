import {NgModule} from '@angular/core';
import {TranslationPipe} from "./pipe/translation.pipe";

@NgModule({
    imports: [],
    declarations: [
        TranslationPipe,
    ],
    exports: [
        TranslationPipe,
    ],
    providers: []
})
export class SharedModule {}