import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {ReplaySubject} from 'rxjs/ReplaySubject';
import {Pageable} from '../../core/model/pageable';
import {FilterState} from '../../shared/service/filter.state';
import {ProductRequestDto} from '../model/dto/product-request.dto';
import {Product} from '../model/product';
import {ProductRepository} from '../repository/product.repository';
import {PageableState} from '../../shared/model/pageable.state';

@Injectable()
export class ProductState implements PageableState {
    private pageable = new ReplaySubject<Pageable<Product>>(1);

    public constructor(private productRepository: ProductRepository,
                       private filterState: FilterState) {
        this.filterState
            .getFilter()
            .switchMap((params) => this.productRepository.getProducts(params))
            .subscribe(this.pageable);
    }

    public getPageable(): Observable<Pageable<Product>> {
        return this.pageable.asObservable();
    }

    public getProduct(productId: number): Observable<Product> {
        const cache = this.pageable
            .take(1)
            .filter((pageable) => pageable.hasDoc(productId))
            .map((pageable) => pageable.docs[pageable.getIndex(productId)]);

        const ajax = this.productRepository.getProduct(productId);

        return Observable
            .concat(cache, ajax)
            .first();
    }

    public addProduct(productDto: ProductRequestDto): Observable<Product> {
        const ajax = this.productRepository
            .postProduct(productDto)
            .publishReplay(1)
            .refCount();

        Observable.combineLatest(ajax, this.pageable)
            .take(1)
            .subscribe(([product, pageable]) => {
                pageable.docs.push(product);
                this.pageable.next(pageable);
            });

        return ajax;
    }

    public updateProduct(product: Product): Observable<undefined> {
        const ajax = this.productRepository
            .putProduct(product)
            .publishReplay(1)
            .refCount();

        ajax.switchMapTo(this.pageable)
            .first((pageable) => pageable.hasDoc(product.id))
            .subscribe((pageable) => {
                pageable.replaceDoc(product);
                this.pageable.next(pageable);
            });

        return ajax;
    }

    public removeProduct(productId: number): Observable<undefined> {
        const ajax = this.productRepository
            .deleteProduct(productId)
            .publishReplay(1)
            .refCount();

        ajax.switchMapTo(this.pageable)
            .first((pageable) => pageable.hasDoc(productId))
            .subscribe((pageable) => {
                pageable.removeDoc(productId);
                this.pageable.next(pageable);
            });

        return ajax;
    }
}
