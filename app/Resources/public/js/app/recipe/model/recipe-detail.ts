import {RecipeDetailDto} from './dto/recipe-detail.dto';
import {Ingredient} from './ingredient';
import {Instruction} from './instruction';
import {Recipe} from './recipe';

export class RecipeDetail extends Recipe {
    public ingredients: Ingredient[];
    public instructions: Instruction[];
    public description: string;

    constructor(dto: RecipeDetailDto) {
        super(dto);

        this.ingredients = dto.ingredients.map((ingredientDto) => new Ingredient(ingredientDto));
        this.instructions = dto.instructions.map((instructionDto) => new Instruction(instructionDto));
        this.description = dto.description;
    }
}
