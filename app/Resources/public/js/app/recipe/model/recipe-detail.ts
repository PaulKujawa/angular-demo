import {RecipeDetailDto} from 'app/recipe/model/dto/recipe-detail.dto';
import {Ingredient} from 'app/recipe/model/ingredient';
import {Instruction} from 'app/recipe/model/instruction';
import {Recipe} from 'app/recipe/model/recipe';

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
