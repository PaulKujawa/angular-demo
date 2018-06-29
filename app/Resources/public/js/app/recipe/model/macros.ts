import {MacrosDto} from 'app/recipe/model/dto/macros.dto';

interface MacrosInterface {
    kcal: number;
    carbs: number;
    protein: number;
    fat: number;
}

export class Macros {
    public total: MacrosInterface;
    public perServing: MacrosInterface;

    constructor(dto: MacrosDto, servings: number) {
        this.total = dto;
        this.perServing = dto;

        this.perServing.kcal = Math.round(dto.kcal / servings);
        this.perServing.carbs = Math.round(dto.carbs / servings);
        this.perServing.protein = Math.round(dto.protein / servings);
        this.perServing.fat = Math.round(dto.fat / servings);
    }
}
