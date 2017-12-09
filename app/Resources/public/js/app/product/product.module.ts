import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {ReactiveFormsModule} from '@angular/forms';
import {SharedModule} from '../shared/shared.module';
import {ProductDetailComponent} from './component/product-detail.component';
import {ProductFilterComponent} from './component/product-filter.component';
import {ProductFormComponent} from './component/product-form.component';
import {ProductListComponent} from './component/product-list.component';
import {ProductComponent} from './component/product.component';
import {ProductRoutingModule} from './product-routing.module';
import {ProductRepository} from './repository/product.repository';
import {ProductState} from './service/product.state';
import {MatButtonModule} from '@angular/material';

@NgModule({
    imports: [
        CommonModule,
        MatButtonModule,
        ReactiveFormsModule,
        SharedModule,
        ProductRoutingModule,
    ],
    declarations: [
        ProductComponent,
        ProductDetailComponent,
        ProductFilterComponent,
        ProductFormComponent,
        ProductListComponent,
    ],
    exports: [],
    providers: [
        ProductRepository,
        ProductState,
    ],
})
export class ProductModule {
}
