import {Injectable} from '@angular/core';
import {ProductRequestDto} from '../model/dto/product-request.dto';
import {Product} from '../model/product';

@Injectable()
export class ProductMapper {
    public mapRequestDto(product: Product): ProductRequestDto {
        return {
            name: product.name,
            vegan: product.vegan,
            gr: product.gr,
            kcal: product.kcal,
            protein: product.protein,
            carbs: product.carbs,
            sugar: product.sugar,
            fat: product.fat,
            gfat: product.gfat,
            manufacturer: product.manufacturer,
        };
    }
}
