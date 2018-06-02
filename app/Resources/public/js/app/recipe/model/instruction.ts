import {InstructionDto} from 'app/recipe/model/dto/instruction.dto';

export class Instruction {
    public id: number;
    public position: number;
    public description: string;
    public created: Date;
    public updated: Date;

    constructor(dto: InstructionDto) {
        this.id = dto.id;
        this.position = dto.position;
        this.description = dto.description;
        this.created = dto.created;
        this.updated = dto.updated;
    }
}
