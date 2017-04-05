import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {SharedModule} from '../shared/shared.module';
import {ProductRepository} from './repository/product.repository';
import {ProductRoutingModule} from './product-routing.module';
import {ProductFilterComponent} from './component/product-filter.component';
import {ProductDetailComponent} from './component/product-detail.component';
import {ProductListComponent} from './component/product-list.component';
import {ProductComponent} from './component/product.component';
import {ProductFormComponent} from './component/product-form.component';
import {ProductMapper} from './mapper/product.mapper';

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
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
    ]
})
export class ProductModule {}
