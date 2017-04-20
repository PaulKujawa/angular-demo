import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Subject} from 'rxjs/Subject';
import {FlashMessage} from '../../core/model/flash-message';
import {Pageable} from '../../core/model/pageable';
import {FlashMessageService} from '../../core/service/flash-message.service';
import {Product} from '../model/product';
import {ProductRepository} from '../repository/product.repository';

@Component({
    template: `
        <product-filter [pagination]="pageable?.pagination" (filter)="onFilter($event)"></product-filter>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <ul class="list-group">
                    <li class="list-group-item app-products__item"
                        (click)="onSelectProduct(product)"
                        *ngFor="let product of pageable?.docs">
                        {{product.name}}
                    </li>
                </ul>
                <button type="button" class="btn btn-primary" (click)="onAddProduct()">
                    {{'app.common.new'|trans}}
                </button>
            </div>
            <div class="col-xs-12 col-sm-6">
                <router-outlet></router-outlet>
            </div>
        </div>
    `,
})
export class ProductListComponent implements OnInit {
    public pageable: Pageable<Product>;
    private filterStream = new Subject<Map<string, string>>();

    constructor(private router: Router,
                private flashMsgService: FlashMessageService,
                private productRepository: ProductRepository) {
    }

    public ngOnInit(): void {
        this.filterStream
            .subscribe((queryParams: Map<string, string>) => this.productRepository.reloadProducts(queryParams));

        this.productRepository.pageable
            .subscribe(
                (pageable: Pageable<Product>) => this.pageable = pageable,
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error)),
            );
    }

    public onAddProduct(): void {
        this.router.navigate(['products/new']);
    }

    public onFilter(filterMap: Map<string, string>): void {
        this.filterStream.next(filterMap);
    }

    public onSelectProduct(product: Product): void {
        const productName = product.name.replace(' ', '-');
        this.router.navigate(['products', product.id, productName]);
    }
}
