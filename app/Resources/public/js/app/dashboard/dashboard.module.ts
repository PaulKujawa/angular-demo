import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {DashboardComponent} from './component/dashboard.component';
import {PlaceholderComponent} from './component/placeholder.component';
import {DashboardRoutingModule} from './dashboard-routing.module';

@NgModule({
    imports: [
        CommonModule,
        DashboardRoutingModule,
    ],
    declarations: [
        DashboardComponent,
        PlaceholderComponent,
    ],
    exports: [],
    providers: [],
})
export class DashboardModule {
}
