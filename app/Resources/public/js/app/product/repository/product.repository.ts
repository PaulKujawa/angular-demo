import {Injectable} from '@angular/core';
import {Http, Response, URLSearchParams} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {PageableFactory} from '../../core/factory/pageable.factory';
import {Pageable} from '../../core/model/pageable';
import {ApiEventHandler} from '../../core/service/api-event.handler';
import {RoutingService} from '../../core/service/routing.service';
import {ProductMapper} from '../mapper/product.mapper';
import {ProductRequestDto} from '../model/dto/product-request.dto';
import {Product} from '../model/product';
import {ProductState} from '../service/product.state';

@Injectable()
export class ProductRepository {
    constructor(private http: Http,
                private apiEventHandler: ApiEventHandler,
                private routingService: RoutingService,
                private productMapper: ProductMapper,
                private productState: ProductState,
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
            .catch((error) => this.apiEventHandler.catchError(error))
            .subscribe((pageable: Pageable<Product>) => this.productState.pageable.next(pageable));
    }

    public getProduct(id: number): Observable<Product> {
        const url = this.routingService.generate('api_get_product', {id: id});

        return this.http.get(url)
            .map((productDto) => new Product(productDto.json()))
            .catch((error) => this.apiEventHandler.catchError(error));
    }

    public postProduct(requestProduct: Product): Observable<Product> {
        const url = this.routingService.generate('api_post_product');
        const productRequestDto = this.productMapper.mapRequestDto(requestProduct);

        return this.http.post(url, {product: productRequestDto})
            .map((productDto) => new Product(productDto.json()))
            .do((product) => {
                this.productState.addProduct(product);
                this.apiEventHandler.postSuccessMessage('app.api.post_success');
            })
            .catch((error) => this.apiEventHandler.catchError(error));
    }

    public putProduct(product: Product): Observable<Response> {
        const url = this.routingService.generate('api_put_product', {id: product.id});
        const productDto = this.productMapper.mapRequestDto(product);

        return this.http.put(url, {product: productDto})
            .do((nil) => {
                this.productState.replaceProduct(product);
                this.apiEventHandler.postSuccessMessage('app.api.update_success');
            })
            .catch((error) => this.apiEventHandler.catchError(error));
    }

    public deleteProduct(id: number): Observable<Response> {
        const url = this.routingService.generate('api_delete_product', {id: id});

        return this.http.delete(url)
            .do((nil) => {
                this.productState.removeProduct(id);
                this.apiEventHandler.postSuccessMessage('app.api.delete_success');
            })
            .catch((error) => this.apiEventHandler.catchError(error));
    }
}
