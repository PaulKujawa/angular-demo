import {HttpClient, HttpParams} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {PageableFactory} from '../../core/factory/pageable.factory';
import {Pageable} from '../../core/model/pageable';
import {RoutingService} from '../../core/service/routing.service';
import {ProductMapper} from '../mapper/product.mapper';
import {ProductResponseDto} from '../model/dto/product-response.dto';
import {Product} from '../model/product';

@Injectable()
export class ProductRepository {
    constructor(private http: HttpClient,
                private routingService: RoutingService,
                private productMapper: ProductMapper,
                private pageableFactory: PageableFactory) {
    }

    public getProducts(filter: HttpParams): Observable<Pageable<Product>> {
        const url = this.routingService.generate('api_get_products');

        return this.http
            .get<Pageable<ProductResponseDto>>(url, {params: filter})
            .map((pageableDto) => this.pageableFactory.getPageable<ProductResponseDto, Product>(pageableDto, Product));
    }

    public getProduct(id: number): Observable<Product> {
        const url = this.routingService.generate('api_get_product', {id: id});

        return this.http
            .get<ProductResponseDto>(url)
            .map((productDto) => new Product(productDto));
    }

    public postProduct(productLike: Product): Observable<Product> {
        const url = this.routingService.generate('api_post_product');
        const productDto = this.productMapper.mapRequestDto(productLike);

        return this.http
            .post<ProductResponseDto>(url, {product: productDto})
            .map((dto) => new Product(dto));
    }

    public putProduct(product: Product): Observable<void> {
        const url = this.routingService.generate('api_put_product', {id: product.id});
        const productDto = this.productMapper.mapRequestDto(product);

        return this.http.put<void>(url, {product: productDto});
    }

    public deleteProduct(id: number): Observable<void> {
        const url = this.routingService.generate('api_delete_product', {id: id});

        return this.http.delete<void>(url);
    }
}
