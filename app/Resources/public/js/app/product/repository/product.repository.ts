import {Injectable} from '@angular/core';
import {Headers, Http, RequestOptions, Response, URLSearchParams} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {ReplaySubject} from 'rxjs/ReplaySubject';
import {PageableFactory} from '../../core/factory/pageable.factory';
import {Pageable} from '../../core/model/pageable';
import {ApiEventHandlerService} from '../../core/service/api-event-handling.service';
import {RoutingService} from '../../core/service/routing.service';
import {ProductMapper} from '../mapper/product.mapper';
import {ProductRequestDto} from '../model/dto/product-request.dto';
import {Product} from '../model/product';

@Injectable()
export class ProductRepository {
    public pageable = new ReplaySubject<Pageable<Product>>(1);

    constructor(private http: Http,
                private apiEventHandlerService: ApiEventHandlerService,
                private routingService: RoutingService,
                private productMapper: ProductMapper,
                private pageableFactory: PageableFactory) {
    }

    public getProducts(filter: Map<string, string>): void {
        const url = this.routingService.generate('api_get_products');
        const queryParameter = new URLSearchParams();
        filter.forEach((value: string, key: string) => queryParameter.set(key, value));

        this.http.get(url, {search: queryParameter})
            .map((pageableDto) => {
                return this.pageableFactory.getPageable<ProductRequestDto, Product>(pageableDto.json(), Product);
            })
            .catch((error) => this.apiEventHandlerService.catchError(error))
            .subscribe((pageable: Pageable<Product>) => this.pageable.next(pageable));
    }

    public getProduct(id: number): Observable<Product> {
        const url = this.routingService.generate('api_get_product', {id: id});

        return this.http.get(url)
            .map((productDto) => new Product(productDto.json()))
            .catch((error) => this.apiEventHandlerService.catchError(error));
    }

    public postProduct(requestProduct: Product): Observable<Product> {
        const url = this.routingService.generate('api_post_product');
        const productRequestDto = this.productMapper.mapRequestDto(requestProduct);

        return this.http.post(url, {product: productRequestDto})
            .map((productDto) => new Product(productDto.json()))
            .do((product) => {
                this.addProduct(product);
                this.apiEventHandlerService.postSuccessMessage('app.api.post_success');
            })
            .catch((error) => this.apiEventHandlerService.catchError(error));
    }

    public putProduct(product: Product): Observable<Response> {
        const url = this.routingService.generate('api_put_product', {id: product.id});
        const productDto = this.productMapper.mapRequestDto(product);

        return this.http.put(url, {product: productDto})
            .do((nil) => {
                this.replaceProduct(product);
                this.apiEventHandlerService.postSuccessMessage('app.api.update_success');
            })
            .catch((error) => this.apiEventHandlerService.catchError(error));
    }

    public deleteProduct(id: number): Observable<Response> {
        const url = this.routingService.generate('api_delete_product', {id: id});

        return this.http.delete(url)
            .do((nil) => {
                this.removeProduct(id);
                this.apiEventHandlerService.postSuccessMessage('app.api.delete_success');
            })
            .catch((error) => this.apiEventHandlerService.catchError(error));
    }

    private replaceProduct(product: Product): void {
        this.pageable.take(1)
            .subscribe((pageable: Pageable<Product>) => {
                const i = pageable.docs.findIndex((p: Product) => p.id === product.id);
                pageable.docs.splice(i, i === -1 ? 0 : 1, product);
                this.pageable.next(pageable);
            });
    }

    private addProduct(product: Product): void {
        this.pageable.take(1)
            .subscribe((pageable: Pageable<Product>) => {
                pageable.docs.push(product);
                this.pageable.next(pageable);
            });
    }

    private removeProduct(id: number): void {
        this.pageable.take(1)
            .subscribe((pageable: Pageable<Product>) => {
                const i = pageable.docs.findIndex((p: Product) => p.id === id);
                pageable.docs.splice(i, i === -1 ? 0 : 1);
                this.pageable.next(pageable);
            });
    }
}
