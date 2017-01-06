import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {SharedModule} from '../shared/shared.module';
import {ProductRepository} from './repository/product.repository';
import {ProductRoutingModule} from './product-routing.module';
import {ProductsComponent} from './component/products.component';
import {ProductComponent} from './component/product.component';
import {ProductFilterComponent} from "./component/product-filter.component";

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        SharedModule,
        ProductRoutingModule,
    ],
    declarations: [
        ProductsComponent,
        ProductComponent,
        ProductFilterComponent,
    ],
    exports: [],
    providers: [
        ProductRepository,
    ]
})
export class ProductModule {}
