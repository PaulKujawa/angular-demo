import {CommonModule} from "@angular/common";
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {HttpModule} from "@angular/http";
import {InquiryComponent} from "./component/inquiry.component";
import {InquiryFormComponent} from "./component/inquiry-form.component";
import {SharedModule} from "../shared/shared.module";

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        HttpModule,
        SharedModule,
    ],
    declarations: [
        InquiryComponent,
        InquiryFormComponent,
    ],
    exports: [],
    providers: []
})
export class InquiryModule {}
