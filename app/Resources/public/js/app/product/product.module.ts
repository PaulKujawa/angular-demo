import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {ReactiveFormsModule} from '@angular/forms';
import {SharedModule} from '../shared/shared.module';
import {ProductDetailComponent} from './component/product-detail.component';
import {ProductFilterComponent} from './component/product-filter.component';
import {ProductFormComponent} from './component/product-form.component';
import {ProductListComponent} from './component/product-list.component';
import {ProductComponent} from './component/product.component';
import {ProductMapper} from './mapper/product.mapper';
import {ProductRoutingModule} from './product-routing.module';
import {ProductRepository} from './repository/product.repository';
import {ProductState} from './service/product.state';

@NgModule({
    imports: [
        CommonModule,
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
        ProductMapper,
        ProductState,
    ],
})
export class ProductModule {
}
