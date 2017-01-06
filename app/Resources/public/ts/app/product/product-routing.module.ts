import {NgModule} from '@angular/core';
import {RouterModule} from '@angular/router';
import {ProductComponent} from './component/product.component';
import {ProductsComponent} from './component/products.component';

@NgModule({
    imports: [
        RouterModule.forChild([
            {path: 'products', component: ProductsComponent},
            {path: 'products/:id/:name', component: ProductComponent},
        ])
    ],
    exports: [RouterModule]
})
export class ProductRoutingModule {}
