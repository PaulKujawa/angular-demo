import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {ReactiveFormsModule} from '@angular/forms';
import {MatButtonModule} from '@angular/material/button';
import {MatInputModule} from '@angular/material/input';
import {SharedModule} from 'app/shared/shared.module';
import {InquiryFormComponent} from 'app/start-page/component/inquiry-form.component';
import {InquiryComponent} from 'app/start-page/component/inquiry.component';
import {StartPageComponent} from 'app/start-page/component/start-page.component';
import {InquiryRepository} from 'app/start-page/repository/inquiry.repository';
import {StartPageRoutingModule} from 'app/start-page/start-page-routing.module';

@NgModule({
    imports: [
        CommonModule,
        MatButtonModule,
        MatInputModule,
        StartPageRoutingModule,
        ReactiveFormsModule,
        SharedModule,
    ],
    declarations: [
        StartPageComponent,
        InquiryComponent,
        InquiryFormComponent,
    ],
    exports: [],
    providers: [
        InquiryRepository,
    ],
})
export class StartPageModule {
}
