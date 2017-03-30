import {ProductResponseDto} from './dto/product-response.dto';

export class Product {
    id: number;
    name: string;
    vegan: boolean;
    gr: number;
    kcal: number;
    protein: number;
    carbs: number;
    sugar: number;
    fat: number;
    gfat: number;
    created: Date;
    updated: Date;
    manufacturer?: string;

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
        this.created = new Date(dto.created);
        this.updated = new Date(dto.updated);
        this.manufacturer = dto.manufacturer;
    }
}
