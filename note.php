 <!-- ID CARD CHARGE -->
                    <div id="IDCardCharge" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="guardIDCardCharge" id="guardIDCardCharge" class="card">
                            <header class="card-header">
                                <h2 class="card-title">ID Card Charge</h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="guard-id-card-amt">Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₦</span>
                                            <input type="text" class="form-control" id="guard-id-card-amt" name="guard_id_card_amt" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="guard-id-card-remark">Remark/Reason</label>
                                        <textarea name="guard_id_card_remark" rows="2" id="guard-id-card-remark" class="form-control" placeholder="Remark"></textarea>
                                        <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Save" />
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>