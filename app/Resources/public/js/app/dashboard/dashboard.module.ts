import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {HttpModule} from '@angular/http';
import {SharedModule} from '../shared/shared.module';
import {InquiryComponent} from './component/inquiry.component';
import {InquiryFormComponent} from './component/inquiry-form.component';
import {InquiryRepository} from './repository/inquiry.repository';
import {DashboardComponent} from './component/dashboard.component';
import {DashboardRoutingModule} from './dashboard-routing.module';

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
