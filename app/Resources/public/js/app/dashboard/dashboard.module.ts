import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {HttpModule} from '@angular/http';
import {SharedModule} from '../shared/shared.module';
import {DashboardComponent} from './component/dashboard.component';
import {InquiryFormComponent} from './component/inquiry-form.component';
import {InquiryComponent} from './component/inquiry.component';
import {DashboardRoutingModule} from './dashboard-routing.module';
import {InquiryRepository} from './repository/inquiry.repository';

@NgModule({
    imports: [
        CommonModule,
        DashboardRoutingModule,
        FormsModule,
        HttpModule,
        SharedModule,
    ],
    declarations: [
        DashboardComponent,
        InquiryComponent,
        InquiryFormComponent,
    ],
    exports: [],
    providers: [
        InquiryRepository,
    ],
})
export class DashboardModule {
}
