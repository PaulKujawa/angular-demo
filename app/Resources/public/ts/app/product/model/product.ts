import {ProductDto} from './dto/product.dto';

export class Product {
    id: number;
    name: string;
    vegan: boolean;
    gr: number;
    protein: number;
    carbs: number;
    sugar: number;
    fat: number;
    gfat: number;
    created: Date;
    updated: Date;
    manufacturer?: string;

    constructor(dto: ProductDto) {
        this.id = dto.id;
        this.name = dto.name;
        this.vegan = dto.vegan;
        this.gr = dto.gr;
        this.protein = dto.protein;
        this.carbs = dto.carbs;
        this.sugar = dto.sugar;
        this.fat = dto.fat;
        this.gfat = dto.gfat;
        this.created = new Date(dto.created);
        this.updated = new Date(dto.updated);
        this.manufacturer = dto.manufacturer;
    }
}
