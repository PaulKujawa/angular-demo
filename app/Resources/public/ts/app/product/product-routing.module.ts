import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {ProductComponent} from './component/product.component';
import {ProductsComponent} from './component/products.component';

const productRoutes: Routes = [
    {path: 'products', component: ProductsComponent},
    {path: 'products/:id/:name', component: ProductComponent},
];

@NgModule({
    imports: [
        RouterModule.forChild(productRoutes),
    ],
    exports: [RouterModule]
})
export class ProductRoutingModule {}
