import {Http, URLSearchParams, Response, Headers, RequestOptions} from '@angular/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {ReplaySubject} from 'rxjs/ReplaySubject';
import {RoutingService} from '../../core/service/routing.service';
import {Product} from '../model/product';
import {Products} from '../model/products';
import {ProductRequestDto} from '../model/dto/product-request.dto';
import {ProductMapper} from '../mapper/product.mapper';

@Injectable()
export class ProductRepository {
    products = new ReplaySubject<Products>(1);

    constructor(private http: Http,
                private routingService: RoutingService,
                private productMapper: ProductMapper) {}

    reloadProducts(filter: Map<string, string>): void {
        const url = this.routingService.generate('api_get_products');
        const queryParameter = new URLSearchParams();
        filter.forEach((value: string, key: string) => queryParameter.set(key, value));

        this.http.get(url, {search: queryParameter})
            .map(products => new Products(products.json()))
            .catch(error => Observable.throw(error.message || error.statusText))
            .subscribe(products => this.products.next(products));
    }

    getProduct(id: number): Observable<Product> {
        const url = this.routingService.generate('api_get_product', {'id': id});

        return this.http.get(url)
            .map(productDto => new Product(productDto.json()))
            .catch(error => Observable.throw(error.message || error.statusText));
    }

    postProduct(product: Product): Observable<Product> {
        const url = this.routingService.generate('api_post_product');
        const headers = new Headers({'Content-Type': 'application/json'}); // TODO set as general header
        const options = new RequestOptions({headers: headers});
        const productDto = this.productMapper.mapRequestDto(product);

        return this.http.post(url, {product: productDto}, options)
            .map(productDto => new Product(productDto.json()))
            .do(product => this.addProduct(product))
            .catch(error => Observable.throw(error.message || error.statusText));
    }

    putProduct(product: Product): Observable<Response> {
        const url = this.routingService.generate('api_put_product', {'id': product.id});
        const headers = new Headers({'Content-Type': 'application/json'}); // TODO set as general header
        const options = new RequestOptions({headers: headers});
        const productDto = this.productMapper.mapRequestDto(product);

        return this.http.put(url, {product: productDto}, options)
            .do(nil => this.replaceProduct(product))
            .catch(error => Observable.throw(error.message || error.statusText));
    }

    deleteProduct(id: number): Observable<Response> {
        const url = this.routingService.generate('api_delete_product', {'id': id});

        return this.http.delete(url)
            .do(nil => this.removeProduct(id))
            .catch(error => Observable.throw(error.message || error.statusText));
    }

    private replaceProduct(product: Product): void {
        this.products.take(1)
            .subscribe((products: Products) => {
                const i = products.docs.findIndex((p: Product) => p.id === product.id);
                products.docs.splice(i, i === -1 ? 0 : 1, product);
                this.products.next(products);
            });
    }

    private addProduct(product: Product): void {
        this.products.take(1)
            .subscribe((products: Products) => {
                products.docs.push(product);
                this.products.next(products);
            });
    }

    private removeProduct(id: number): void {
        this.products.take(1)
            .subscribe((products: Products) => {
                const i = products.docs.findIndex((p: Product) => p.id === id);
                products.docs.splice(i, i === -1 ? 0 : 1);
                this.products.next(products);
            });
    }
}
