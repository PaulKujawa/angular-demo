import {ProductRequestDto} from './dto/product-request.dto';
import {ProductResponseDto} from './dto/product-response.dto';

export class Product {
    public id: number;
    public name: string;
    public vegan: boolean;
    public gr: number;
    public kcal: number;
    public protein: number;
    public carbs: number;
    public sugar: number;
    public fat: number;
    public gfat: number;

    constructor(dto: ProductResponseDto) {
        this.id = dto.id;
        this.name = dto.name;
        this.vegan = dto.vegan;
        this.gr = dto.gr;
        this.kcal = dto.kcal;
        this.protein = dto.protein;
        this.carbs = dto.carbs;
        this.sugar = dto.sugar;
        this.fat = dto.fat;
        this.gfat = dto.gfat;
    }

    public map(): ProductRequestDto {
        const copy = Object.assign({}, this);
        delete copy.id;

        return copy;
    }
}
