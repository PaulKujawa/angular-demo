import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {DashboardComponent} from 'app/dashboard/component/dashboard.component';
import {PlaceholderComponent} from 'app/dashboard/component/placeholder.component';
import {DashboardRoutingModule} from 'app/dashboard/dashboard-routing.module';

@NgModule({
    imports: [
        CommonModule,
        DashboardRoutingModule,
    ],
    declarations: [
        DashboardComponent,
        PlaceholderComponent,
    ],
})
export class DashboardModule {
}
