import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {ReactiveFormsModule} from '@angular/forms';
import {MatButtonModule} from '@angular/material/button';
import {MatInputModule} from '@angular/material/input';
import {SharedModule} from '../shared/shared.module';
import {InquiryFormComponent} from './component/inquiry-form.component';
import {InquiryComponent} from './component/inquiry.component';
import {StartPageComponent} from './component/start-page.component';
import {InquiryRepository} from './repository/inquiry.repository';
import {StartPageRoutingModule} from './start-page-routing.module';

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
