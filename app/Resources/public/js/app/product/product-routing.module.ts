import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {AuthenticationGuard} from '../core/service/auth-guard.service';
import {ProductDetailComponent} from './component/product-detail.component';
import {ProductListComponent} from './component/product-list.component';
import {ProductComponent} from './component/product.component';

const productRoutes: Routes = [
    {
        path: 'products',
        component: ProductComponent,
        canActivate: [AuthenticationGuard],
        children: [
            {
                path: '',
                component: ProductListComponent,
                canActivateChild: [AuthenticationGuard],
                children: [
                    {
                        path: ':id/:name',
                        component: ProductDetailComponent,
                    },
                    {
                        path: 'new',
                        component: ProductDetailComponent,
                    },
                ],
            },
        ],
    },
];

@NgModule({
    imports: [
        RouterModule.forChild(productRoutes),
    ],
    exports: [RouterModule],
})
export class ProductRoutingModule {
}
